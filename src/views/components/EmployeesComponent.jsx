import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getEmployees } from '../../controllers/employeeSlice';

import LoadingComponent from './LoadingComponent';
import GroupMembers from './GroupMembers';

function EmployeesComponent() {
  const {
    employeesLoading,
    employeesError,
    employeesErrorMessage,
    employeesStatusCode,
    employees,
  } = useSelector((state) => state.employee);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getEmployees());
  }, [dispatch]);

  if (employeesLoading) {
    return <LoadingComponent />;
  }

  return (
    <>
      {Array.isArray(employees) && (
        <>
          <h1 className="title">Employees</h1>

          <GroupMembers group={employees} />
        </>
      )}
    </>
  );
}

export default EmployeesComponent;
