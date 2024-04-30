function TaxList(props) {
  const { tax, title } = props;

  const handleClick = (slug) => {
    window.location.href = slug;
  };

  return (
    Array.isArray(tax) && (
      <div className="project-tags">
        <h4 className="title">{title}</h4>

        <div className="tags-row">
          {tax.map((project_tag, index) => (
            <button
              key={index}
              className="tag"
              onClick={() => handleClick(project_tag.url)}>
              <h3>{project_tag.title}</h3>
            </button>
          ))}
        </div>
      </div>
    )
  );
}

export default TaxList;
