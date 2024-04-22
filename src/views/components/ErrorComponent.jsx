function ErrorComponent(props) {
  const { message } = props;

  return (
    <main className="error">
      <div className="status-bar card error">
        <span>
          <h4>{message}</h4>
        </span>
      </div>
    </main>
  );
}

export default ErrorComponent;
