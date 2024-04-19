import React from 'react';

import MemberNavigationComponent from './MemberNavigationComponent';

function MemberIntroductionComponent(props) {
  const { title, avatarURL, fullName, greeting, founder_resume } = props;

  const portfolioElement = document.getElementById('portfolio');

  return (
    <main class="member-intro">
      {(founder_resume || portfolioElement) && (
        <MemberNavigationComponent resume={founder_resume} />
      )}

      <h2 class="title">{title}</h2>

      <div class="member">
        <div class="member-card card">
          <div class="member-pic">
            <img src={avatarURL} alt="" />
          </div>
        </div>
        <h4 class="title">{fullName}</h4>
      </div>

      {greeting && (
        <div class="author-card card">
          <p class="author-greeting">{greeting}</p>
        </div>
      )}
    </main>
  );
}

export default MemberIntroductionComponent;
