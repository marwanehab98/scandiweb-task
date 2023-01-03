import { BrowserRouter } from 'react-router-dom';
import './App.css';
import Routes from "./Routes";


function App() {

  return (
    <div>
      <div className="App">
        <BrowserRouter>
          <Routes />
        </BrowserRouter>
      </div>
      <footer>
        <div>
          <div>
            Scandiweb Test assignment
          </div>
        </div>
      </footer>
    </div>
  );

}

export default App;
