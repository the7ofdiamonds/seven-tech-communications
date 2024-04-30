import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';

import { getSkill } from '../controllers/taxonomiesSlice';
import { getFoundersWithTerm } from '../controllers/founderSlice';

import HeaderIconComponent from './components/HeaderIconComponent';
import GroupMembers from './components/GroupMembers';

function Skill() {
  const { skill } = useParams();

  const {
    taxonomiesLoading,
    taxonomiesError,
    taxonomiesErrorMessage,
    id,
    title,
    icon,
    description,
  } = useSelector((state) => state.taxonomies);
  const {
    founderLoading,
    founderError,
    founderErrorMessage,
    founderStatusCode,
    founders,
  } = useSelector((state) => state.founder);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getSkill(skill));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getFoundersWithTerm({ taxonomy: 'Skills', term: skill }));
  }, [dispatch]);

  return (
    <main className="skill">
      <HeaderIconComponent icon={icon} title={title} />

      {description && (
        <div className="card">
          <p>{description}</p>
        </div>
      )}

      <GroupMembers group={founders} />
    </main>
  );
}

export default Skill;
