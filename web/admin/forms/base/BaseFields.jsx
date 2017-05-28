import React from 'react';
import Formsy from 'formsy-react';

export const Hidden = React.createClass({
  mixins: [Formsy.Mixin],

  render() {
    return (
      <input type="hidden" className="form-control" value={this.getValue()} />
    );
  },
});

export const Input = React.createClass({
  mixins: [Formsy.Mixin],

  changeValue(event) {
    this.setValue(event.currentTarget.value);
  },

  render() {
    const type = this.props.type || 'text';
    return (
      <div className="form-group">
        <label className="col-sm-2 control-label">{this.props.label}</label>
        <div className="col-sm-10">
          <input type={type} className="form-control" onChange={this.changeValue} value={this.getValue()} />
        </div>
      </div>
    );
  },
});

export const TextArea = React.createClass({
  mixins: [Formsy.Mixin],

  changeValue(event) {
    this.setValue(event.currentTarget.value);
  },

  render() {
    return (
      <div className="form-group">
        <label className="col-sm-2 control-label">{this.props.label}</label>
        <div className="col-sm-10">
          <textarea className="form-control" onChange={this.changeValue} value={this.getValue()} />
        </div>
      </div>
    );
  },
});

export const Checkbox = React.createClass({
  mixins: [Formsy.Mixin],

  changeValue(event) {
    this.setValue(event.currentTarget.checked);
  },

  render() {
    const id = `checkbox_${Date.now()}`;
    return (
      <div className="form-group">
        <label className="col-sm-2 control-label">{this.props.label}</label>
        <div className="col-sm-10">
          <div className="switch-button switch-button-yesno switch-button-sm">
            <input type="checkbox" id={id} value="1" checked={this.getValue() === true} onChange={this.changeValue} />
            <span><label htmlFor={id}></label></span>
          </div>
        </div>
      </div>
    );
  },
});

export const Select = React.createClass({
  mixins: [Formsy.Mixin],

  changeValue(event) {
    this.setValue(event.currentTarget.value);
  },

  renderOption(item, key, value) {
    const optionProps = Object.assign({}, item);
    return (
      <option key={key} {...optionProps}>{item.label}</option>
    )
  },

  render() {
    const optionNodes = this.props.options.map((item, key) => this.renderOption(item, key, this.props.value));

    return (
      <div className="form-group">
        <label className="col-sm-2 control-label">{this.props.label}</label>
        <div className="col-sm-10">
          <select value={this.getValue()} onChange={this.changeValue}>
            {optionNodes}
          </select>
        </div>
      </div>
    );
  },
});
