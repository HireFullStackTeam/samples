/* @flow weak */
import {Record, List, fromJS} from 'immutable';
import * as actions from './actionCreators';

const State = new Record({
  components: new List(),
  activeTab: 'layers',
  activeComponent: 0,
  isShiftPressed: false,
  editorHeight: 0,
  updatingComponents: false,
  creatingComponent: false
});

const canvasReducer = (state = new State(), action) => {
  switch (action.type) {

    case actions.TOGGLE_TAB: {
      return state.set('activeTab', action.payload);
    }

    case actions.CREATE_COMPONENT_START: {
      return state.set('creatingComponent', true);
    }

    case actions.CREATE_COMPONENT_SUCCESS: {
      const {data} = action.payload;
      const component = fromJS(data).set('visibility', true);

      return state.update('components', components =>
        components.push(component)
      ).set('creatingComponent', false);
    }

    case actions.LOAD_COMPONENTS: {
      return state.set('components', fromJS(action.payload));
    }

    case actions.ADD_COMPONENTS: {
      return state.update('components', components => components.push(...fromJS(action.payload)));
    }

    case actions.UPDATE_COMPONENT: {
      const {index, payload: options} = action;
      return state.mergeIn(['components', index], options);
    }

    case actions.UPDATE_COMPONENTABLE: {
      const {index, payload: options} = action;
      return state.mergeIn(['components', index, 'componentable'], options);
    }

    case actions.REORDER_COMPONENTS: {
      return state.set('components', action.payload);
    }

    case actions.UPDATE_COMPONENTS_START: {
      return state.set('updatingComponents', true);
    }

    case actions.UPDATE_COMPONENTS_SUCCESS: {
      return state.merge({
        components: fromJS(action.payload.data),
        updatingComponents: false
      });
    }

    case actions.DELETE_COMPONENT_SUCCESS: {
      return state.update('components', components => components.delete(action.payload));
    }

    case actions.SET_SHIFT_STATUS: {
      return state.set('isShiftPressed', action.payload);
    }

    case actions.SET_ACTIVE_COMPONENT: {

      const componentableType = state.getIn(['components', action.payload, 'componentable_type']);

      return state.merge({
        activeComponent: action.payload,
        activeTab: componentableType
      });
    }

    case actions.SET_EDITOR_HEIGHT: {
      return state.set('editorHeight', action.payload);
    }

    default: {
      return state;
    }
  }
};

export default canvasReducer;
