import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useLocation } from 'react-router-dom';

import ContentComponent from './components/ContentComponent';

import LoadingComponent from './components/LoadingComponent';

import { getContent } from '../controllers/contentSlice';

function Faq() {
const dispatch = useDispatch();

  const {
    contentLoading,
    contentStatusCode,
    contentErrorMessage,
    title,
    content,
  } = useSelector((state) => state.content);

  useEffect(() => {
    dispatch(getContent('/faq'));
  }, [dispatch]);

  useEffect(() => {
    if (contentStatusCode && contentErrorMessage) {
      setMessageType('error');
      setMessage(contentErrorMessage);
    }
  }, [contentStatusCode, contentErrorMessage]);

  if (contentLoading) {
    return <LoadingComponent />;
  }

  return (
    <>
      <main className="faq">
        <h2 className="title">{title}</h2>

        <ContentComponent content={content} />
      </main>
    </>
  );
}

export default Faq;
