// @flow
import React from 'react';
import {connect} from 'react-redux';

import UINavigationBar from '../UI/UINavigationBar';
import {NavigationBar} from '../../Navigation';

class Authentication extends React.Component {
  render() {
    const {authorization} = this.props;

    return (
      <div>
        <NavigationBar
          authorization={authorization}
        >
          <UINavigationBar/>
        </NavigationBar>
        <main>my main body</main>
      </div>
    );
  }
}

export default connect(
  (state: Object) => ({
    authorization: state.authorize.authorization
  })
)(Authentication);
