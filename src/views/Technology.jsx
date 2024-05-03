import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useParams } from 'react-router-dom';

import { getTechnology } from '../controllers/taxonomiesSlice';
import { getFoundersWithTerm } from '../controllers/founderSlice';
import { getExecutivesWithTerm } from '../controllers/executiveSlice';
import { getManagingMembersWithTerm } from '../controllers/managingMemberSlice';
import { getFreelancersWithTerm } from '../controllers/freelancerSlice';
import { getEmployeesWithTerm } from '../controllers/employeeSlice';

import HeaderIconComponent from './components/HeaderIconComponent';
import GroupMembers from './components/GroupMembers';

function Technology() {
  const { technology } = useParams();

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
    dispatch(getTechnology(technology));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getFoundersWithTerm({ taxonomy: 'Technologies', term: technology }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getExecutivesWithTerm({ taxonomy: 'Technologies', term: technology }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getManagingMembersWithTerm({ taxonomy: 'Technologies', term: technology }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getFreelancersWithTerm({ taxonomy: 'Technologies', term: technology }));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getEmployeesWithTerm({ taxonomy: 'Technologies', term: technology }));
  }, [dispatch]);

  return (
    <main className="technology">
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

export default Technology;
