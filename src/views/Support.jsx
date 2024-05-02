import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useLocation } from 'react-router-dom';

import { getContent } from '../controllers/contentSlice';

import LoadingComponent from './components/LoadingComponent';
import ContentComponent from './components/ContentComponent';
import MessageCardComponent from './components/MessageCardComponent';
import StatusBarComponent from './components/StatusBarComponent';


function SupportComponent() {
const dispatch = useDispatch();

  const { contentLoading, contentStatusCode, contentErrorMessage, content, title } =
    useSelector((state) => state.content);
  const {
    contactLoading,
    contactStatusCode,
    contactErrorMessage,
    contactSuccessMessage,
  } = useSelector((state) => state.contact);

  useEffect(() => {
    dispatch(getContent('/support'));
  }, [dispatch]);

  useEffect(() => {
    if (contentStatusCode && contentErrorMessage) {
      setMessageType('error');
      setMessage(contentErrorMessage);
    }
  }, [contentStatusCode, contentErrorMessage]);

  useEffect(() => {
    if (contactStatusCode && contactErrorMessage) {
      setMessageType('error');
      setMessage(contactErrorMessage);
    }
  }, [contactStatusCode, contactErrorMessage]);

  useEffect(() => {
    if (contactSuccessMessage) {
      setMessageType('success');
      setMessage(contactSuccessMessage);

      setTimeout(() => {
        window.location.href = `/`;
      }, 3000);
    }
  }, [contactSuccessMessage]);

  const [messageType, setMessageType] = useState('');
  const [message, setMessage] = useState('');

  if (contactLoading) {
    return <LoadingComponent />;
  }

  return (
    <>
      <main className="support">
        <h2 className="title">{title}</h2>

        <ContentComponent content={content} />

        <div className="support-card card">
          <MessageCardComponent page={'/support'} />
        </div>

        <StatusBarComponent messageType={messageType} message={message} />
      </main>
    </>
  );
}

export default SupportComponent;
