import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';

import { getFramework } from '../controllers/taxonomiesSlice';
import { getFoundersWithTerm } from '../controllers/founderSlice';
import { getExecutivesWithTerm } from '../controllers/executiveSlice';
import { getManagingMembersWithTerm } from '../controllers/managingMemberSlice';
import { getFreelancersWithTerm } from '../controllers/freelancerSlice';
import { getEmployeesWithTerm } from '../controllers/employeeSlice';

import HeaderIconComponent from './components/HeaderIconComponent';
import GroupMembers from './components/GroupMembers';

function Framework() {
  const { framework } = useParams();

  const {
    taxonomiesLoading,
    taxonomiesErrorMessage,
    id,
    title,
    icon,
    description,
    url
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
    dispatch(getFramework(framework));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getFoundersWithTerm({ taxonomy: 'Frameworks', term: framework }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getExecutivesWithTerm({ taxonomy: 'Frameworks', term: framework }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getManagingMembersWithTerm({ taxonomy: 'Frameworks', term: framework }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getFreelancersWithTerm({ taxonomy: 'Frameworks', term: framework }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getEmployeesWithTerm({ taxonomy: 'Frameworks', term: framework }));
  }, [dispatch]);

  return (
    <main className="framework">
      <HeaderIconComponent icon={icon} title={title} url={url}/>

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

export default Framework;
