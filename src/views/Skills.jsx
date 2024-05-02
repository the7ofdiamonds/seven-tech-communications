import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getSkills } from '../controllers/taxonomiesSlice';

import LoadingComponent from './components/LoadingComponent';
import ErrorComponent from './components/ErrorComponent';
import IconComponent from './components/IconComponent';

function Skills() {
  const { taxonomiesLoading, taxonomiesErrorMessage, skills } =
    useSelector((state) => state.taxonomies);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getSkills());
  }, [dispatch]);

  if (taxonomiesLoading) {
    return <LoadingComponent />;
  }

  if (taxonomiesErrorMessage) {
    return <ErrorComponent message={taxonomiesErrorMessage} />;
  }

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
