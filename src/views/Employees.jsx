import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getEmployees } from '../controllers/employeeSlice';

import LoadingComponent from './components/LoadingComponent';
import ErrorComponent from './components/ErrorComponent';
import GroupMembers from './components/GroupMembers';

function Employees() {
  const {
    employeeLoading,
    employeeErrorMessage,
    employeeStatusCode,
    employees,
  } = useSelector((state) => state.employee);
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getEmployees());
  }, [dispatch]);

  if (employeeLoading) {
    return <LoadingComponent />;
  }

  if (employeeErrorMessage) {
    return <ErrorComponent message={employeeErrorMessage} />;
  }

  return (
    <>
      <main className="employees">
        {Array.isArray(employees) && (
          <>
            <h1 className="title">Employees</h1>

            <GroupMembers group={employees} />
          </>
        )}
      </main>
    </>
  );
}

export default Employees;
