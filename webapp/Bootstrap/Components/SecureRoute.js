// @flow
import React from 'react';
import {Redirect, Route} from 'react-router-dom';

// type PropsType = {
//   authorization: Object,
//   security: Function
// };

export default class SecureRoute extends React.Component {
  render() {
    const {redirectTo = null, component: Component, security: Security, authorization, path} = this.props;

    return (
      <Route
        path={path}
        render={(props: Object) => {
          if (!authorization.authorized) {
            return Security;
          } else if (redirectTo) {
            return (<Redirect to={redirectTo}/>);
          } else {
            return (<Component {...props}/>);
          }
        }}
      />
    );
  }
}
