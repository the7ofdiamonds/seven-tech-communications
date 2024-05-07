import React from 'react';

function ContentComponent(props) {
  const { content } = props;

  return (
    <>
      {content && (
        <>
          {content.map((content, index) => (
            <div
              key={index}
              dangerouslySetInnerHTML={{ __html: content }}></div>
          ))}
        </>
      )}
    </>
  );
}

export default ContentComponent;
