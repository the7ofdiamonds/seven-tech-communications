import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getSkills } from '../controllers/taxonomiesSlice';

import IconComponent from './components/IconComponent';

function Skills() {
  const { skillsLoading, skillsError, skillsErrorMessage, skills } =
    useSelector((state) => state.taxonomies);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getSkills());
  }, [dispatch]);

  return (
    <main className="skills">
      <h1 className="title">skills</h1>

      {Array.isArray(skills) &&
        skills.map((skill, index) => (
          <>
            <a href={`${skill.url}`}>
              <div className="skill">
                <IconComponent key={index} icon={skill.icon} />
                <h3 className="title">{skill.title}</h3>
              </div>
            </a>
          </>
        ))}
      <div>Skills</div>
    </main>
  );
}

export default Skills;
