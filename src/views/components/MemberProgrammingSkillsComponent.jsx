import React, { useEffect, useRef } from 'react';
import IconComponent from './IconComponent';

function MemberProgrammingSkillsComponent(props) {
  const { skills } = props;
  const skillsSlideRef = useRef(null);

  useEffect(() => {
    const skillsSlide = skillsSlideRef.current;

    if (skillsSlide) {
      const totalSkills = skillsSlide.children.length;

      for (let i = 0; i < totalSkills; i++) {
        skillsSlide.appendChild(skillsSlide.children[i].cloneNode(true));
      }

      document.documentElement.style.setProperty('--total-skills', totalSkills);
    }
  }, [skills]);

  return (
    <>
      {Array.isArray(skills) && skills.length > 0 && (
        <div className="author-skills">
          <div className="author-skills-slide" ref={skillsSlideRef}>
            {skills.map((skill, index) => (
              <div className="icon">
                <IconComponent key={index} icon={skill} />
              </div>
            ))}
          </div>
        </div>
      )}
    </>
  );
}

export default MemberProgrammingSkillsComponent;
