import Member from './Member';

function GroupMembers(props) {
  const { group } = props;

  return (
    <>
      {group && (
        <div className="group">
          {group.map((group_member) => (
            <Member key={group_member.id} member={group_member} />
          ))}
        </div>
      )}
    </>
  );
}

export default GroupMembers;
