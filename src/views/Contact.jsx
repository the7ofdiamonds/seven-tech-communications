import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import ContentComponent from './components/ContentComponent';
import MessageCardComponent from './components/MessageCardComponent';
import StatusBarComponent from './components/StatusBarComponent';
import LoadingComponent from './components/LoadingComponent';

import { getContent } from '../controllers/contentSlice';

function ContactComponent() {
const dispatch = useDispatch();

  const { contentLoading, contentStatusCode, contentErrorMessage, title, content } =
    useSelector((state) => state.content);
  const {
    contactLoading,
    contactStatusCode,
    contactErrorMessage,
    contactSuccessMessage,
  } = useSelector((state) => state.contact);

  useEffect(() => {
    dispatch(getContent('/contact'));
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

  if (contentLoading) {
    return <LoadingComponent />;
  }

  return (
    <>
      <main className="contact">
        <h2 className="title">{title}</h2>

        <ContentComponent content={content} />

        <div className="contact-card card">
          <MessageCardComponent page={'/contact'} />
        </div>

        <StatusBarComponent messageType={messageType} message={message} />
      </main>
    </>
  );
}

export default ContactComponent;
