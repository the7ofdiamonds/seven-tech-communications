import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import { getMissionStatement } from '../controllers/aboutSlice';
import { getContent } from '../controllers/contentSlice';

import LoadingComponent from '../loading/LoadingComponent';

import ContentComponent from '../views/components/ContentComponent';

function About() {
  const page = 'about';

  const dispatch = useDispatch();

  const { missionStatement } = useSelector((state) => state.about);
  const {
    contentLoading,
    contentStatusCode,
    contentErrorMessage,
    title,
    content,
  } = useSelector((state) => state.content);

  useEffect(() => {
    if (contentStatusCode && contentErrorMessage) {
      setMessageType('error');
      setMessage(contentErrorMessage);
    }
  }, [contentStatusCode, contentErrorMessage]);

  useEffect(() => {
    dispatch(getMissionStatement());
  }, [dispatch]);

  useEffect(() => {
    dispatch(getContent(page));
  }, [dispatch]);

  if (contentLoading) {
    return <LoadingComponent />;
  }

  return (
    <>
      <main>
        <h2 className="title">{title}</h2>

        <div className="mission-statement-card card">
          <h3 className="mission-statement">
            <q>{missionStatement}</q>
          </h3>
        </div>

        <ContentComponent content={content} />
      </main>
    </>
  );
}

export default About;
