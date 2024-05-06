function Member(props) {
  const { member } = props;

  return (
    <>
      {member && typeof member === 'object' && (
        <div className="member-card card">
          <div className="member-pic">
            <a href={member.user_url ? member.user_url : ''}>
              <img src={member.avatar_url} alt="" />
            </a>
          </div>

          <div className="member-name">
            <h4 className="title">{member.full_name}</h4>
          </div>

          {member.title && (
            <div className="role">
              <h5>{member.title}</h5>
            </div>
          )}

          <div className="member-contact">
            <a href={`mailto:${member.email}`}>
              <i className="fa fa-envelope fa-fw"></i>
            </a>
          </div>
        </div>
      )}
    </>
  );
}

export default Member;
