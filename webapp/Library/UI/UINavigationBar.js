// @flow
import React from 'react';
import FaCog from 'react-icons/lib/fa/cog';

export default class UINavigationBar extends React.Component {
  render() {
    return (
      <div className={'header__toolbar header__toolbar--albums header__toolbar--visible'}>
        <div className={'button'} id="button_settings" title="Settings">
          <FaCog/>
        </div>
        <a className="header__title">Library</a>
        <input className="header__search" type="text" name="search" placeholder="Search …"/>
        <a className="header__clear">&times;</a>
        <a className="header__divider"></a>
        <a className="button button_add" title="Add">
          <svg className="iconic"><use xlinkHref="#plus"></use></svg>
        </a>
      </div>
    );
  }
}
