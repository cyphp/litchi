// @flow
import React from 'react';
import {Provider} from 'react-redux';
import {HashRouter as Router} from 'react-router-dom';

import {Application} from '../../Gateway';

export default class Main extends React.Component {
  render() {
    const {store} = this.props;

    return (
      <Provider store={store}>
        <Router>
          <Application/>
        </Router>
      </Provider>
    );
  }
}
