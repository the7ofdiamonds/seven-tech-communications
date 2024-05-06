import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';

import { getSkill } from '../controllers/taxonomiesSlice';
import { getFoundersWithTerm } from '../controllers/founderSlice';
import { getExecutivesWithTerm } from '../controllers/executiveSlice';
import { getManagingMembersWithTerm } from '../controllers/managingMemberSlice';
import { getFreelancersWithTerm } from '../controllers/freelancerSlice';
import { getEmployeesWithTerm } from '../controllers/employeeSlice';

import LoadingComponent from './components/LoadingComponent';
import ErrorComponent from './components/ErrorComponent';
import HeaderIconComponent from './components/HeaderIconComponent';
import GroupMembers from './components/GroupMembers';

function Skill() {
  const { skill } = useParams();

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

  const {
    taxonomiesLoading,
    taxonomiesErrorMessage,
    id,
    title,
    icon,
    description,
    url,
  } = useSelector((state) => state.taxonomies);
  const { founders } = useSelector((state) => state.founder);
  const { executives } = useSelector((state) => state.executive);
  const { managingMembers } = useSelector((state) => state.managingMember);
  const { freelancers } = useSelector((state) => state.freelancer);
  const { employees } = useSelector((state) => state.employee);

  if (taxonomiesLoading) {
    return <LoadingComponent />;
  }

  if (taxonomiesErrorMessage) {
    return <ErrorComponent message={taxonomiesErrorMessage} />;
  }

  return (
    <main className="skill">
      <HeaderIconComponent icon={icon} title={title} url={url} />

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
