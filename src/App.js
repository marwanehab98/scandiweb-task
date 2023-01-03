import { BrowserRouter } from 'react-router-dom';
// import { useEffect, useState } from 'react';
import './App.css';
import Routes from "./Routes";


function App() {

  return (
    <div className="App">
      <section>
        <BrowserRouter>
          <Routes />
        </BrowserRouter>
      </section>
      <footer>Scandiweb Test assignment</footer>;
    </div>
  );

}

export default App;
