import React from 'react';

import IconComponent from './IconComponent';

function HeaderIconComponent(props) {
  const { title, icon, url } = props;

  return (
    <div className="header-icon">
      {icon != '' ? (
        <IconComponent icon={icon} url={url} />
      ) : (
        <h1 className="title">{title}</h1>
      )}
    </div>
  );
}

export default HeaderIconComponent;
