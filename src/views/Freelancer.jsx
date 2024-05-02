import React, { useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';

import { getFreelancer } from '../controllers/freelancerSlice.js';

import LoadingComponent from './components/LoadingComponent.jsx';
import MemberKnowledgeComponent from './components/MemberKnowledgeComponent.jsx';
import MemberComponent from './components/MemberComponent.jsx';
import ContentComponent from './components/ContentComponent.jsx';

import { getContent } from '../controllers/contentSlice.js';

function Freelancer() {
  const url = new URL(window.location.href);
  const pageSlug = url.pathname;

  const { freelancer } = useParams();
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getContent(pageSlug));
  }, [dispatch]);

  useEffect(() => {
    dispatch(getFreelancer(freelancer));
  }, [dispatch]);

  const {
    freelancerLoading,
    freelancerErrorMessage,
    title,
    avatarURL,
    fullName,
    bio,
    projectTypes,
    skills,
    frameworks,
    technologies,
    resume,
  } = useSelector((state) => state.freelancer);

  const { content } = useSelector((state) => state.content);

  if (freelancerLoading) {
    return <LoadingComponent />;
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

export default Freelancer;
