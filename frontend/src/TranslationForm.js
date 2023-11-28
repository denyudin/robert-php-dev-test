const languages = ['EN', 'ES', 'FR'];

export default function TranslationForm({ unit, onSubmit }) {

  const {id, source_language = languages[0], source_text = '', target_language = languages[1], target_text = ''} = unit;
  const [sourceLanguage, setSourceLanguage] = React.useState(source_language);
  const [sourceText, setSourceText] = React.useState(source_text);
  const [targetLanguage, setTargetLanguage] = React.useState(target_language);
  const [targetText, setTargetText] = React.useState(target_text);

  React.useEffect(() => {
    setSourceLanguage(source_language);
    setSourceText(source_text);
    setTargetLanguage(target_language);
    setTargetText(target_text);
  }, [unit]);

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit({sourceLanguage, sourceText, targetLanguage, targetText });
  };

  return (
    <form onSubmit={handleSubmit}>
      <div style={{display: 'flex', alignItems: 'space-between'}}>
        <div style={{flex: 1}}>
          <div>
            <label>Source language:
              <select name="source_language" onChange={e => setSourceLanguage(e.target.value)} value={sourceLanguage}>
                {languages.map(lang =>
                  <option value={lang} key={lang}>{lang}</option>
                )}
              </select>
            </label>
          </div>
          <label htmlFor="source_text" id="source_text">Source text:</label>
          <textarea rows="3" id="source_text" style={{width: '100%'}} onChange={e => setSourceText(e.target.value)} value={sourceText}/>
        </div>
        <div style={{flex: 1}}>
          <div>
            <label>Target language:
              <select name="target_language" onChange={e => setTargetLanguage(e.target.value)} value={targetLanguage}>
                {languages.map(lang =>
                  <option value={lang} key={lang}>{lang}</option>
                )}
              </select>
            </label>
          </div>
          <label htmlFor="target_text" id="target_text">Target text:</label>
          <textarea rows="3" id="target_text" style={{width: '100%'}} onChange={e => setTargetText(e.target.value)} value={targetText}/>
        </div>
      </div>
      <input type="submit" value={id ? "Update" : "Add"} />
    </form>
  );
}
