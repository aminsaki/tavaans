import axios from 'axios';
import {myErrors} from "@/commons/helpers/errors.js";

class ApiService {
  // POST request
  async post(resource, data) {
    try {
      const response = await axios.post(resource, data);
      if (response.data.status === "true") {
        return response.data;
      }
    } catch (error) {
      return myErrors(error); // Centralized error handling
    }
  }

  // GET request
  async get(resource) {
    try {
      const response = await axios.get(resource);
      if (response.data.status === "true") {
        return response.data;
      }
    } catch (error) {
      return myErrors(error);
    }

  }

  // DELETE request
  async delete(resource) {
    try {
      const response = await axios.delete(resource);
      return response.data;
    } catch (error) {
      return myErrors(error);
    }
  }

  // PUT request
  async put(resource, data) {
    try {
      const response = await axios.put(resource, data);
      return response.data
    } catch (error) {
      return myErrors(error);
    }
  }
  async patch(resource, data) {
    try {
      const response = await axios.patch(resource, data);
      if (response.data.status === "true") {
        return response.data;
      }
    } catch (error) {
      return myErrors(error);
    }
  }
}

export default new ApiService();
