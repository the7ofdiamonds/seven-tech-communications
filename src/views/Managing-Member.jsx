import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';

import { getManagingMember } from '../controllers/managingMemberSlice.js';
import { getContent } from '../controllers/contentSlice.js';

import LoadingComponent from './components/LoadingComponent.jsx';
import ErrorComponent from './components/ErrorComponent.jsx';
import MemberKnowledgeComponent from './components/MemberKnowledgeComponent.jsx';
import MemberComponent from './components/MemberComponent.jsx';
import ContentComponent from './components/ContentComponent.jsx';

function ManagingMember() {
  const { managingMember } = useParams();
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getManagingMember(managingMember));
  }, [dispatch]);

  const {
    managingMemberLoading,
    managingMemberErrorMessage,
    title,
    avatarURL,
    fullName,
    bio,
    projectTypes,
    skills,
    frameworks,
    technologies,
    resume,
    content
  } = useSelector((state) => state.managingMember);

  if (managingMemberLoading) {
    return <LoadingComponent />;
  }

  if (managingMemberErrorMessage) {
    return <ErrorComponent message={managingMemberErrorMessage} />;
  }

  const knowledge = [
    ...(projectTypes || []),
    ...(skills || []),
    ...(frameworks || []),
    ...(technologies || []),
  ];

  return (
    <>
      <main class="author-intro" id="author_intro">
        <MemberComponent
          title={title}
          avatarURL={avatarURL}
          fullName={fullName}
          bio={bio}
          resume={resume}
        />

        <ContentComponent content={content} />

        <MemberKnowledgeComponent knowledge={knowledge} />
      </main>
    </>
  );
}

export default ManagingMember;
