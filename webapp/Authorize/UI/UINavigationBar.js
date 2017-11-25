// @flow
import React from 'react';

type PropsType = {
  title?: string
};

export default class UINavigationBar extends React.Component {
  constructor(props: PropsType) {
    super(props);
  }

  render() {
    return (
      <div className="header__toolbar header__toolbar--public header__toolbar--visible">
        <a className="button" id="button_signin" title="Sign In" onClick={window.lychee.loginDialog}>
          <svg className="iconic">
            <use xlinkHref="#account-login"></use>
          </svg>
        </a>
        <a className="header__title">Albums</a>
        <a className="header__hostedwith">Hosted with Lychee</a>
      </div>
    );
  }
}
