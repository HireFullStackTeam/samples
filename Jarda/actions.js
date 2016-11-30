/* @flow */
import * as actions from './actionCreators';
import {fromJS} from 'immutable';
import {createApiConfig, API} from '../../api.conf';
import {showSavedLabel} from '../../../common/editor/project/actions';
import ResponseError from '../../lib/ResponseError';


/**
 * Set active component to deal with (after click on it)
 * @param index
 */
export const setActiveComponent = (index: number) => ({
  type: actions.SET_ACTIVE_COMPONENT,
  payload: index
});




/**
 * Add component
 * @param type
 * @param id
 */
export const createComponent = (type: string, id: number) => ({fetch, getState, dispatch}) => {
  const getPromise = async() => {

    const {URL, METHOD} = API.CREATE_COMPONENT;

    const response = await fetch(URL(), createApiConfig(METHOD, {
      type: type,
      project_id: getState().project.get('id'),
      componentable: {
        [`${type}_id`]: id || null
      }
    }));

    if (response.status !== 200) {
      const error = await response.json();
      throw new ResponseError(error);
    }
    const newActiveComponentIndex = getState().canvas.get('components').size;

    dispatch(setActiveComponent(newActiveComponentIndex));
    dispatch(toggleTab(type));

    return response.json();
  };

  return {
    type: actions.CREATE_COMPONENT,
    payload: getPromise()
  };
};




/**
 * Loads components from retrieved project to store
 * @param components
 * @return {{type, payload: *}}
 */
export const loadComponents = (components: []) => {
  return {
    type: actions.LOAD_COMPONENTS,
    payload: fromJS(components)
  };
};




/**
 * Add new components to the store
 * @param components
 */
export const addComponents = (components: {}) => ({
  type: actions.ADD_COMPONENTS,
  payload: components
});




/**
 * Update component (only locally)
 * @param index
 * @param options
 * @returns {{type, payload: {index: *, options: *}}}
 */
export const updateComponent = (index: number, options: {}) => {
  return {
    type: options.state && options.content ? actions.UPDATE_COMPONENTABLE : actions.UPDATE_COMPONENT,
    index,
    payload: options
  };
};




/**
 * Update all components in canvas (API)
 */
export const updateComponents = () => ({fetch, getState, dispatch}) => {
  const getPromise = async() => {
    const {URL, METHOD} = API.UPDATE_COMPONENTS;

    const components = getState().canvas.get('components');
    if (!components && components.size === 0) return;

    const response = await fetch(URL(), createApiConfig(METHOD, {
      components: {
        ...components.toJS()
      }
    }));

    if (response.status !== 200) {
      const error = await response.json();
      throw new ResponseError(error);
    }

    dispatch(showSavedLabel());

    return response.json();
  };

  return {
    type: actions.UPDATE_COMPONENTS,
    payload: getPromise()
  };
};




/**
 * Reorder components
 * @param componentList
 */
export const reorderComponents = (componentList) => ({
  type: actions.REORDER_COMPONENTS,
  payload: fromJS(componentList)
});




/**
 * Toggle tab in menu
 * @param tab
 */
export const toggleTab = (tab: string) => ({
  type: actions.TOGGLE_TAB,
  payload: tab
});




/**
 * Delete component from canvas
 * @param index
 * @param id
 */
export const deleteComponent = (index: number, id: number) => ({fetch}) => {
  const getPromise = async() => {
    const {URL, METHOD} = API.DELETE_COMPONENT;

    const response = await fetch(URL(id), createApiConfig(METHOD));

    if (response.status !== 204) {
      const error = await response.json();
      throw new ResponseError(error);
    }

    return index;
  };

  return {
    type: actions.DELETE_COMPONENT,
    payload: getPromise()
  };
};




/**
 *
 * @param isPressed
 */
export const setShiftStatus = (isPressed: boolean) => ({
  type: actions.SET_SHIFT_STATUS,
  payload: isPressed
});

