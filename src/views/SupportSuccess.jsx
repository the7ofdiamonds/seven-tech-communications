import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import ContentComponent from '../views/components/ContentComponent';

import { getContent } from '../controllers/contentSlice';

function SupportSuccessComponent() {
  const dispatch = useDispatch();

  const { content } = useSelector((state) => state.content);

  useEffect(() => {
    dispatch(getContent('support-success'));
  }, [dispatch]);

  const urlParams = new URLSearchParams(window.location.search);
  const firstName = urlParams.get('first_name');
  const email = urlParams.get('email');

  return (
    <>
      <main className="contact-success">
        <ContentComponent content={content} />

        <div className="status-bar card success">
          <span>
            <h4>
              Thank You, {firstName}. Your message has been sent, and a reply
              will be sent to {email}.
            </h4>
          </span>
        </div>
      </main>
    </>
  );
}

export default SupportSuccessComponent;
