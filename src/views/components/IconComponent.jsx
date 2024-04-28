function IconComponent(props) {
  const { icon } = props;
console.log(icon);
  return (
    <>
      {icon instanceof Object && (
        <>
          {icon['icon_url'] && <img src={`${icon['icon_url']}`} />}

          {icon['fa_icon'] && <i className={`${icon['fa_icon']}`}></i>}
        </>
      )}
    </>
  );
}

export default IconComponent;
