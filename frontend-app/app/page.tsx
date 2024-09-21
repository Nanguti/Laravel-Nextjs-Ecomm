import React from "react";
import SectionHeader from "./home/SectionHeader";
import SectionBestDeals from "./home/SectionBestDeals";
import SectionProducts from "./home/SectionProducts";
import SectionBrands from "./home/SectionBrands";

const page = () => {
  return (
    <div>
      <div className="my-7">
        <SectionHeader />
      </div>

      <div className="mb-32">
        <SectionBestDeals />
      </div>

      <div className="mb-32">
        <SectionProducts />
      </div>

      <div className="mb-32">
        <SectionBrands />
      </div>
    </div>
  );
};

export default page;
