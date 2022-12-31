import { BrowserRouter } from 'react-router-dom';
// import { useEffect, useState } from 'react';
import './App.css';
import Routes from "./Routes";


function App() {

  return (
    <div>
      <BrowserRouter>
        <Routes />
      </BrowserRouter>
    </div>
  );

}

export default App;
