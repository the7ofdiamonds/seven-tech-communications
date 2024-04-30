import React from 'react';

import IconComponent from './IconComponent';

function HeaderIconComponent(props) {
  const { title, icon } = props;

  return (
    <div className="header-icon">
      <IconComponent icon={icon} />
      <h1 className="title">{title}</h1>
    </div>
  );
}

export default HeaderIconComponent;
