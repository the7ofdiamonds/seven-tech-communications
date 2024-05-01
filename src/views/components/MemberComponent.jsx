import React from 'react';

import MemberNavigationComponent from './MemberNavigationComponent';

function MemberIntroductionComponent(props) {
  const { title, avatarURL, fullName, bio, resume } = props;

  const portfolioElement = document.getElementById('seven_tech_portfolio');

  return (
    <>
      {(resume || portfolioElement) && (
        <MemberNavigationComponent
          resume={resume}
          portfolioElement={portfolioElement}
        />
      )}

      <h2 class="title">{fullName}</h2>

      <div className="author-info">
        <div class="author">
          <div class="author-card card">
            <div class="author-pic">
              <img src={avatarURL} alt="" />
            </div>
          </div>
          <h4 class="title">{title}</h4>
        </div>

        {bio && (
          <div class="author-card card">
            <p class="author-bio">{bio}</p>
          </div>
        )}
      </div>
    </>
  );
}

export default MemberIntroductionComponent;
