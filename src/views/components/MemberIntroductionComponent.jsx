import React from 'react';

import MemberNavigationComponent from './MemberNavigationComponent';

function MemberIntroductionComponent(props) {
  const { title, avatarURL, fullName, bio, founder_resume } = props;

  const portfolioElement = document.getElementById('seven_tech_portfolio');

  return (
    <main class="author-intro" id='author_intro'>
      {(founder_resume || portfolioElement) && (
        <MemberNavigationComponent resume={founder_resume} portfolioElement={portfolioElement} />
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
    </main>
  );
}

export default MemberIntroductionComponent;
