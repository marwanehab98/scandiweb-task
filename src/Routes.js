// import React, { lazy, Suspense, useContext } from "react";
import { Route, Routes } from "react-router-dom";
import ProductsList from './components/ProductsList/ProductsList';
import CreateProduct from './components/CreateProduct/CreateProduct';

const Routess = () => {
    return (
        <Routes>
            <Route index element={<ProductsList />} />
            <Route path="/" element={<ProductsList />} />
            <Route path="/addProduct" element={<CreateProduct />} />
        </Routes>
    );
};
export default Routess;
