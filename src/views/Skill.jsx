import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';

import { getSkill } from '../controllers/taxonomiesSlice';

function Skill() {
  const { skill } = useParams();

  const {
    skillsLoading,
    skillsError,
    skillsErrorMessage,
    title,
    icon,
    description,
  } = useSelector((state) => state.taxonomies);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getSkill(skill));
  }, [dispatch]);

  return (
    <main className="skill">
      <h1 className="title">{title}</h1>

      <div className="card">
        <p>{description}</p>
      </div>
    </main>
  );
}

export default Skill;
