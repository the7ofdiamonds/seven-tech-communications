import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getFrameworks } from '../controllers/taxonomiesSlice';

import LoadingComponent from './components/LoadingComponent';
import ErrorComponent from './components/ErrorComponent';
import IconComponent from './components/IconComponent';

function Frameworks() {
  const { taxonomiesLoading, taxonomiesErrorMessage, frameworks } =
    useSelector((state) => state.taxonomies);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getFrameworks());
  }, [dispatch]);

  if (taxonomiesLoading) {
    return <LoadingComponent />;
  }

  if (taxonomiesErrorMessage) {
    return <ErrorComponent message={taxonomiesErrorMessage} />;
  }

  return (
    <main className="frameworks">
      <h1 className="title">frameworks</h1>

      {Array.isArray(frameworks) &&
        frameworks.map((skill, index) => (
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

export default Frameworks;
