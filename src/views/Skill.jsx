import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';

import { getSkill } from '../controllers/taxonomiesSlice';
import { getFoundersWithTerm } from '../controllers/founderSlice';
import { getExecutivesWithTerm } from '../controllers/executiveSlice';
import { getManagingMembersWithTerm } from '../controllers/managingMemberSlice';
import { getFreelancersWithTerm } from '../controllers/freelancerSlice';
import { getEmployeesWithTerm } from '../controllers/employeeSlice';

import HeaderIconComponent from './components/HeaderIconComponent';
import GroupMembers from './components/GroupMembers';

function Skill() {
  const { skill } = useParams();

  const {
    taxonomiesLoading,
    taxonomiesErrorMessage,
    id,
    title,
    icon,
    description,
  } = useSelector((state) => state.taxonomies);
  const {
    founderLoading,
    founderErrorMessage,
    founders,
  } = useSelector((state) => state.founder);
  const {
    executiveLoading,
    executiveErrorMessage,
    executives,
  } = useSelector((state) => state.executive);
  const {
    managingMemberLoading,
    managingMemberErrorMessage,
    managingMembers,
  } = useSelector((state) => state.managingMember);
  const {
    freelancerLoading,
    freelancerErrorMessage,
    freelancers,
  } = useSelector((state) => state.freelancer);
  const {
    employeeLoading,
    employeeErrorMessage,
    employees,
  } = useSelector((state) => state.employee);

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getSkill(skill));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getFoundersWithTerm({ taxonomy: 'Skills', term: skill }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getExecutivesWithTerm({ taxonomy: 'Skills', term: skill }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getManagingMembersWithTerm({ taxonomy: 'Skills', term: skill }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getFreelancersWithTerm({ taxonomy: 'Skills', term: skill }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getEmployeesWithTerm({ taxonomy: 'Skills', term: skill }));
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
      <GroupMembers group={executives} />
      <GroupMembers group={managingMembers} />
      <GroupMembers group={freelancers} />
      <GroupMembers group={employees} />
    </main>
  );
}

export default Skill;
