// @flow
import React from 'react';
import {connect} from 'react-redux';

import UINavigationBar from '../UI/UINavigationBar';
import {NavigationBar} from '../../Navigation';

class Dashboard extends React.Component {
  render() {
    const {authorization} = this.props;

    return (
      <div>
        <NavigationBar
          authorization={authorization}
        >
          <UINavigationBar/>
        </NavigationBar>
        {authorization.authorized && <main>my main body</main>}
      </div>
    );
  }
}

export default connect(
  (state: Object) => ({
    authorization: state.authorize.authorization
  })
)(Dashboard);
