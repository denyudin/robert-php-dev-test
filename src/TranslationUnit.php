<?php


class TranslationsController {
    private TranslationUnit $translationUnitModel;
    private HistoryTranslationUnits $historyTranslationUnitModel;

    public function __construct(TranslationUnit $translationUnitModel, HistoryTranslationUnits $historyTranslationUnitModel) {
        $this->translationUnitModel = $translationUnitModel;
        $this->historyTranslationUnitModel = $historyTranslationUnitModel;
    }

    public function handleGetAll(): string|false {
        $translationUnits = $this->translationUnitModel->getAll();
        return json_encode($translationUnits);
    }

    public function handleGetById(int $id): string|false {
        $translationUnit = $this->translationUnitModel->getById($id);
        if ($translationUnit !== null) {
            return json_encode($translationUnit);
        } else {
            http_response_code(404);
            return json_encode(['error' => 'Not Found']);
        }
    }

    public function handlePost(): string|false {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $this->translationUnitModel->add($data['sourceLanguage'], $data['targetLanguage'], $data['sourceText'], $data['targetText']);
        if ($id) {
            return json_encode(['success' => true, 'id' => $id]);
        } else {
            http_response_code(404);
            return json_encode(['error' => 'Something went wrong']);
        }
    }

    public function handlePut(int $id): string|false {
        $data = json_decode(file_get_contents('php://input'), true);
        $tu = $this->translationUnitModel->getById($id);
        $this->historyTranslationUnitModel->add($id, $tu);
        $success = $this->translationUnitModel->update($id, $data['sourceLanguage'], $data['targetLanguage'], $data['sourceText'], $data['targetText']);
        if ($success) {
            return json_encode(['success' => true]);
        } else {
            http_response_code(404);
            return json_encode(['error' => 'Something went wrong']);
        }
    }
}


class TranslationUnit {

    private PDO $db;
    private string $table = 'translation_units';

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll(): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id, source_language, target_language, source_text, target_text FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add(string $source_language, string $target_language, string $source_text, string $target_text): int {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (source_language, target_language, source_text, target_text) VALUES (?, ?, ?, ?)");
        $stmt->execute([$source_language, $target_language, $source_text, $target_text]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, string $source_language, string $target_language, string $source_text, string $target_text): bool {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET source_language = ?, target_language = ?, source_text = ?, target_text = ? WHERE id = ?");
        $res = $stmt->execute([$source_language, $target_language, $source_text, $target_text, $id]);
        return $res;
    }
}


class HistoryTranslationUnits {

    private PDO $db;
    private string $table = 'history_translation_units';

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function add($translation_unit_id, $old_data) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (translation_unit_id, old_data_json) VALUES (?, ?)");
        return $stmt->execute([$translation_unit_id, json_encode($old_data)]);
    }
}