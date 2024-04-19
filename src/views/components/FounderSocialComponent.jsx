import React from 'react';

function FounderSocialComponent(props) {
  const { social_networks } = props;

  console.log(social_networks);

  return (
    <>
      {Array.isArray(social_networks) && social_networks.length > 0 ? (
        <div className="social-networks">
          {social_networks.map((social_network, index) => (
            <a href={`${social_network['link']}`} target="_blank">
              <i
                key={index}
                className={`fa-brands fa-${social_network[
                  'icon'
                ].toLowerCase()}`}></i>
            </a>
          ))}
        </div>
      ) : null}
    </>
  );
}

export default FounderSocialComponent;
