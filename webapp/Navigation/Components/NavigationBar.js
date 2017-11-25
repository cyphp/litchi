// @flow
import React from 'react';

type PropsType = {
  authorization: Object
};

export default class NavigationBar extends React.Component {
  constructor(props: PropsType) {
    super(props);
  }

  render() {
    return (
      <header className={'header'}>
        {this.props.children}
      </header>
    );
  }
}
