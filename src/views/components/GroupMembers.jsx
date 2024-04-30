function GroupMembers(props) {
  const { group } = props;

  return (
    <>
      {group?.length > 0 &&
        group.map((group_member) => (
          <div className="group" key={group_member.id}>
            {group_member && typeof group_member === 'object' && (
              <div className="author-card card">
                <div className="author-pic">
                  <a href={group_member.user_url ? group_member.user_url : ''}>
                    <img src={group_member.avatar_url} alt="" />
                  </a>
                </div>

                <div className="author-name">
                  <h4 className="title">
                    {group_member.full_name}
                  </h4>
                </div>

                {Array.isArray(group_member.roles) &&
                  group_member.roles.map((role) => (
                    <div className="role">
                      <h5>{role}</h5>
                    </div>
                  ))}

                <div className="author-contact">
                  <a href={`mailto:${group_member.email}`}>
                    <i className="fa fa-envelope fa-fw"></i>
                  </a>
                </div>
              </div>
            )}
          </div>
        ))}
    </>
  );
}

export default GroupMembers;
