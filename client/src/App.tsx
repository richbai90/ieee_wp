import React from 'react';
import {Router} from '@reach/router';
import Home from './routes/Home';

const App: React.FC = () => {
  return (
    <Router>
      <Home path="/" />
    </Router>
  );
}

export default App;
