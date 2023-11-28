const TranslationList = props => {
  return (
    <table style={{width: '100%', border: '1px solid black', borderCollapse: 'collapse'}}>
      <thead>
      <tr>
        <th style={{ width: '40px' }}>ID</th>
        <th>Source</th>
        <th>Target</th>
        <th style={{ width: '40px' }}>Action</th>
      </tr>
      </thead>
      <tbody>
      {props.units.map(unit => (
        <tr key={unit.id}>
          <td>{unit.id}</td>
          <td><b>{unit.source_language}:</b>{unit.source_text}</td>
          <td><b>{unit.target_language}:</b>{unit.target_text}</td>
          <td>
            <button onClick={() => props.onClickEdit(unit.id)}>&#9998;</button>
          </td>
        </tr>
      ))}
      </tbody>
    </table>
  );
}

export default TranslationList;