import React, { useEffect, useRef } from 'react';
import IconComponent from './IconComponent';

function MemberKnowledgeComponent(props) {
  const { knowledge } = props;
  const skillsSlideRef = useRef(null);
console.log(knowledge);
  useEffect(() => {
    const skillsSlide = skillsSlideRef.current;

    if (skillsSlide) {
      const totalSkills = skillsSlide.children.length;

      for (let i = 0; i < totalSkills; i++) {
        skillsSlide.appendChild(skillsSlide.children[i].cloneNode(true));
      }

      document.documentElement.style.setProperty('--total-skills', totalSkills);
    }
  }, [knowledge]);

  return (
    <>
      <div className="author-knowledge">
        <div className="author-knowledge-slide" ref={skillsSlideRef}>
          {Array.isArray(knowledge) && knowledge.length > 0 && 
            knowledge.map((skill) => (
              <div className="icon" key={skill.id}>
                <IconComponent icon={skill} />
              </div>
            ))
          }
        </div>
      </div>
    </>
  );
  
}

export default MemberKnowledgeComponent;
