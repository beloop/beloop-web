import React from 'react';
import Formsy from 'formsy-react';

export const Input = React.createClass({
  mixins: [Formsy.Mixin],

  changeValue(event) {
    this.setValue(event.currentTarget.value);
  },

  render() {
    return (
      <div className="form-group">
        <label className="col-sm-2 control-label">{this.props.label}</label>
        <div className="col-sm-10">
          <input type="text" className="form-control" onChange={this.changeValue} value={this.getValue()} />
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
