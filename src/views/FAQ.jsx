import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import ContentComponent from '../views/components/ContentComponent';

import { getContent } from '../controllers/contentSlice';

function Faq() {
  const dispatch = useDispatch();

  const { content } = useSelector((state) => state.content);

  useEffect(() => {
    dispatch(getContent('faq'));
  }, [dispatch]);

  return (
    <>
      <main className="faq">
        <h2 className="title">FAQ</h2>

        <ContentComponent content={content} />
      </main>
    </>
  );
}

export default Faq;
