import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getSkills } from '../controllers/skillsSlice';

import IconComponent from './components/IconComponent';

function Skills() {
  const { skillsLoading, skillsError, skillsErrorMessage, skills } =
    useSelector((state) => state.skills);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getSkills());
  }, [dispatch]);

  return (
    <main className="skills">
      {Array.isArray(skills) &&
        skills.map((skill, index) => (
          <>
            <div className="skill">
              <a href={`${skill.url}`}>
                <IconComponent key={index} icon={skill.icon} />
              </a>
              <h3 className="title">{skill.title}</h3>
            </div>
          </>
        ))}
      <div>Skills</div>
    </main>
  );
}

export default Skills;
