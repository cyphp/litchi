// @flow
import {combineReducers} from 'redux';

import authorization from './Authorization';

const AuthorizeReducers = combineReducers({
  authorization
});

export {
  AuthorizeReducers
};
