const Testsession = ({ userId, userEmail, monTruc }) => {
  return (
    <>
      <h1>Test Session React</h1>
      <p>{monTruc}</p>
      {userId && userEmail ? (
        <p>
          Connecté : {userEmail} (ID : {userId})
        </p>
      ) : (
        <p>Utilisateur non connecté</p>
      )}
    </>
  );
};

export default Testsession;
