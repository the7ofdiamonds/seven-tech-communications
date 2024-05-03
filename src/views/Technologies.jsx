import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getTechnologies } from '../controllers/taxonomiesSlice';

import LoadingComponent from './components/LoadingComponent';
import ErrorComponent from './components/ErrorComponent';
import IconComponent from './components/IconComponent';

function Technologies() {
  const { taxonomiesLoading, taxonomiesErrorMessage, technologies } =
    useSelector((state) => state.taxonomies);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getTechnologies());
  }, [dispatch]);

  if (taxonomiesLoading) {
    return <LoadingComponent />;
  }

  if (taxonomiesErrorMessage) {
    return <ErrorComponent message={taxonomiesErrorMessage} />;
  }

  return (
    <main className="technologies">
      <h1 className="title">technologies</h1>

      {Array.isArray(technologies) &&
        technologies.map((skill, index) => (
          <>
            <a href={`${skill.url}`}>
              <div className="skill">
                <IconComponent key={index} icon={skill.icon} />
                <h3 className="title">{skill.title}</h3>
              </div>
            </a>
          </>
        ))}
    </main>
  );
}

export default Technologies;
