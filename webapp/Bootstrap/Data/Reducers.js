// @flow
import {combineReducers} from 'redux';

import {AuthorizeReducers} from '../../Authorize';

export default combineReducers({
  authorize: AuthorizeReducers
});
