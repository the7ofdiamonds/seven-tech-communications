import React, { useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';

import ContentComponent from '../views/components/ContentComponent';

import { getMissionStatement } from '../controllers/aboutSlice';
import { getContent } from '../controllers/contentSlice';

function About() {
  const dispatch = useDispatch();

  // const missionStatement = 'Turning ideas into tangible assets ';
  const { missionStatement } = useSelector((state) => state.about);
  const { content } = useSelector((state) => state.content);

  useEffect(() => {
    dispatch(getMissionStatement());
  }, [dispatch]);

  useEffect(() => {
    dispatch(getContent('about'));
  }, [dispatch]);

  return (
    <>
      <h2>ABOUT</h2>

      <div className="mission-statement-card card">
        <h3 className="mission-statement">
          <q>{missionStatement}</q>
        </h3>
      </div>

      <ContentComponent content={content} />
    </>
  );
}

export default About;
