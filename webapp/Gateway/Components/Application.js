// @flow
import React from 'react';
import {connect} from 'react-redux';

import {SecureRoute} from '../../Bootstrap';
import {Authentication} from '../../Authorize';
import {Dashboard} from '../../Library';

type PropsType = {
  params: Object,
  authorization: Object
};

class Application extends React.Component {
  constructor(props: PropsType) {
    super(props);
  }

  render() {
    const {authorization} = this.props;

    return (
      <div>
        <SecureRoute
          path={'/dashboard'}
          component={Dashboard}
          security={<Authentication/>}
          authorization={authorization}
        />
        <SecureRoute
          path={'/'}
          component={Dashboard}
          security={<Authentication/>}
          authorization={authorization}
        />
      </div>
    );
  }
}

export default connect(
  (state: Object) => ({
    authorization: state.authorize.authorization
  })
)(Application);
