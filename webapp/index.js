// @flow
import React from 'react'; // eslint-disable-line
import {render} from 'react-dom';
import {createStore} from 'redux';
// import 'bootstrap/dist/css/bootstrap.min.css';

import {Main, Reducers} from './Bootstrap';

let store = createStore(Reducers);

render(
  <Main store={store}/>,
  document.getElementById('root')
);
